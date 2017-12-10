<?php
/**
 * 插入排序算法
 * User: end_wiki
 * Date: 2017/12/10
 * Time: 14:10
 */
namespace src\framework\algorithm;

class InsertionSort {

    public function sort(array $data){
        $dataLength = count($data);
        for($i = 1; $i < $dataLength;$i++){
            for($j = $i;$j > 0; $j--){
                if($data[$j] < $data[$j - 1]){
                    // 交换
                    $temp = $data[$j - 1];
                    $data[$j - 1] = $data[$j];
                    $data[$j] = $temp;
                }else{
                    break;
                }
            }
        }
        return $data;
    }
}