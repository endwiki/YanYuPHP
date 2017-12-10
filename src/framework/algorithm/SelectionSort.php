<?php
/**
 * 选择排序算法
 * User: end_wiki
 * Date: 2017/12/10
 * Time: 13:17
 */
namespace src\framework\algorithm;

class SelectionSort{

    /**
     * 一维数组排序
     * @param array $rawData 原始数据
     * @return array
     */
    public function sort(array $rawData) : array{
        for($i = 0; $i < count($rawData);$i++){
            $minIndex = $i;
            // 选择最大的值
            for($j = $i + 1; $j < count($rawData);$j++){
                if($rawData[$j] < $rawData[$minIndex]){
                    $minIndex = $j;
                }
            }
            // 交换
            $temp = $rawData[$minIndex];
            $rawData[$minIndex] = $rawData[$i];
            $rawData[$i] = $temp;
        }

        return $rawData;
    }

}