<?php
/**
 * 选择排序算法
 * User: end_wiki
 * Date: 2017/12/10
 * Time: 13:17
 */
namespace yanyu\algorithm;

class SelectionSort{

    /**
     * 一维数组排序
     * @param array $rawData 原始数据
     * @return array
     */
    public function sort(array $rawData) : array{
        $dataLength = count($rawData);
        for($i = 0; $i < $dataLength;$i++){
            $minIndex = $i;
            // 选择最大的值
            for($j = $i + 1; $j < $dataLength;$j++){
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