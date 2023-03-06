<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Words;
use App\Services\UploadsManager;
use Illuminate\Http\Request;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;

class UploadController extends Controller
{
    protected $manager;

    public function __construct(UploadsManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Show page of files / subfolders
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->manager->folderInfo($folder);

        return view('admin.upload.index', $data);
    }

    // 添加如下四个方法到UploadController控制器类
    /**
     * 创建新目录
     */
    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder = $request->get('folder') . '/' . $new_folder;

        $result = $this->manager->createDirectory($folder);

        if ($result === true) {
            return redirect()
                ->back()
                ->with('success', '目录「' . $new_folder . '」创建成功.');
        }

        $error = $result ?: "创建目录出错.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }

    /**
     * 删除文件
     */
    public function deleteFile(Request $request)
    {
        $del_file = $request->get('del_file');
        $path = $request->get('folder') . '/' . $del_file;

        $result = $this->manager->deleteFile($path);

        if ($result === true) {
            return redirect()
                ->back()
                ->with('success', '文件「' . $del_file . '」已删除.');
        }

        $error = $result ?: "文件删除出错.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }

    /**
     * 删除目录
     */
    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');
        $folder = $request->get('folder') . '/' . $del_folder;

        $result = $this->manager->deleteDirectory($folder);

        if ($result === true) {
            return redirect()
                ->back()
                ->with('success', '目录「' . $del_folder . '」已删除');
        }

        $error = $result ?: "An error occurred deleting directory.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }

    /**
     * 上传文件
     */
    public function uploadFile(UploadFileRequest $request)
    {
        $file = $_FILES['file'];
        $fileName = $request->get('file_name');
        $fileName = $fileName ?: $file['name'];
        $path = str_finish($request->get('folder'), '/') . $fileName;
        $content = File::get($file['tmp_name']);

        $result = $this->manager->saveFile($path, $content);

        if ($result === true) {
            return redirect()
                ->back()
                ->with("success", '文件「' . $fileName . '」上传成功.');
        }

        $error = $result ?: "文件上传出错.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }
    //导入文件
    public function import(Request $request){
        $filename=$request->file('file');
        //加载excel文件
        $objPHPExcelReader = \PHPExcel_IOFactory::load($filename);

        $sheet = $objPHPExcelReader->getSheet(0); // 读取第一个工作表(编号从 0 开始)
        $highestRow = $sheet->getHighestRow();           // 取得总行数
        $highestColumn = $sheet->getHighestColumn();     // 取得总列数

        $arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
// 一次读取一列
        $res_arr = array();
        for ($row = 2; $row <= $highestRow; $row++) {
            $row_arr = array();
            for ($column = 0; $arr[$column] != 'B'; $column++) {
                $val = $sheet->getCellByColumnAndRow($column, $row)->getValue();
                $row_arr[] = $val;
            }
            $res_arr[] = $row_arr;
        }
        $ids = array_map('array_shift', $res_arr);
        $redis=Redis::connection();
        foreach ($ids as $key=>$value){
           $redis->zadd('words',$key,$value);
        }
        return redirect()->route('blog.home')
            ->with('success', '添加成功.');
    }

}
