<?php
/**
 * 日期时间处理类
 * User: end_wiki
 * Date: 2018/1/3
 * Time: 16:00
 */
namespace yanyu\tools;

class DateTime{

    /**
     * 获取昨天
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getYesterday(String $formatStr = 'Y-m-d H:i:s'){
        $dataTime = new \DateTime(date('Y-m-d H:i:s',time()));
        $dataInterval = new \DateInterval('P1D');
        $dataTime->sub($dataInterval);
        return $dataTime->format($formatStr);
    }

    /**
     * 获取明天
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getTomorrow(String $formatStr = 'Y-m-d H:i:s'){
        $dataTime = new \DateTime(date('Y-m-d H:i:s',time()));
        $dataInterval = new \DateInterval('P1D');
        $dataTime->add($dataInterval);
        return $dataTime->format($formatStr);
    }

    /**
     * 获取下个月
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getNextMonth(String $formatStr = 'Y-m-d H:i:s'){
        $dataTime = new \DateTime(date('Y-m-d H:i:s',time()));
        $dataInterval = new \DateInterval('P1M');
        $dataTime->add($dataInterval);
        return $dataTime->format($formatStr);
    }

    /**
     * 获取上个月
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getLastMonth(String $formatStr = 'Y-m-d H:i:s'){
        $dataTime = new \DateTime(date('Y-m-d H:i:s',time()));
        $dataInterval = new \DateInterval('P1M');
        $dataTime->sub($dataInterval);
        return $dataTime->format($formatStr);
    }

    /**
     * 获取一年中的第一个月
     * @param String|Integer|null $year 年份 default null
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getFirstMonthOfYear($year = null,String $formatStr = 'Y-m-d H:i:s'){
        if(is_null($year)){
            $year = date('Y',time());
        }
        $dateTime = (new \DateTime($year . '-01-01 00:00:00'))->format($formatStr);
        return $dateTime;
    }

    /**
     * 获取一年中的最后一个月
     * @param String|Integer|null $year 年份 default null
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getLastMonthOfYear($year = null,String $formatStr = 'Y-m-d H:i:s'){
        if(is_null($year)){
            $year = date('Y',time());
        }
        $dateTime = (new \DateTime($year . '-12-01 00:00:00'))->format($formatStr);
        return $dateTime;
    }

    /**
     * 获取指定年份的最后一天
     * @param String|Integer|null $year 年份 default null
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getLastDayOfYear($year = null,String $formatStr = 'Y-m-d H:i:s'){
        if(is_null($year)){
            $year = date('Y',time());
        }
        $dateTime = (new \DateTime($year . '-12-31 00:00:00'))->format($formatStr);
        return $dateTime;
    }

    /**
     * 获取指定年份的最后一天
     * @param String|Integer|null $year 年份 default null
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getFirstDayOfYear($year = null,String $formatStr = 'Y-m-d H:i:s'){
        if(is_null($year)){
            $year = date('Y',time());
        }
        $dateTime = (new \DateTime($year . '-01-01 00:00:00'))->format($formatStr);
        return $dateTime;
    }

    /**
     * 获取指定年份月份的第一天
     * @param String|Integer|null $year 年份 default null
     * @param  String|Integer|null $month 月份 default null
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getFirstDayOfMonth($year = null,$month = null,String $formatStr = 'Y-m-d H:i:s'){
        if(is_null($year)){
            $year = date('Y',time());
        }
        if(is_null($month)){
            $month = date('m',time());
        }
        $dateTime = (new \DateTime($year . '-' . $month . '-01 00:00:00'))->format($formatStr);
        return $dateTime;
    }

    /**
     * 获取指定年份月份的最后一天
     * @param String|Integer|null $year 年份 default null
     * @param  String|Integer|null $month 月份 default null
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getLastDayOfMonth($year = null,$month = null,String $formatStr = 'Y-m-d H:i:s'){
        if(is_null($year)){
            $year = date('Y',time());
        }
        if(is_null($month)){
            $month = date('m',time());
        }
        $month += 1;            // 加一个月，用以之后减去一天
        $dateTime = (new \DateTime($year . '-' . $month . '-01 00:00:00'))
            ->sub(new \DateInterval('P1D'))
            ->format($formatStr);
        return $dateTime;
    }

    /**
     * 获取下个星期的某一天
     * @param Integer $offset 偏移值，比如 1 即 星期一 default 0
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getNextWeekFirstDay(int $offset = 0,String $formatStr = 'Y-m-d H:i:s'){
        $currentWeekNum = date('w');
        $dataTime = new \DateTime(date('Y-m-d H:i:s',time()));
        $dataInterval = new \DateInterval('P1W');
        return $dataTime->add($dataInterval)
            ->sub(new \DateInterval('P' . $currentWeekNum . 'D'))
            ->add(new \DateInterval('P' . $offset . 'D'))
            ->format($formatStr);
    }

    /**
     * 获取上个星期的某一天
     * @param Integer $offset 偏移值，比如 1 即 星期一 default 0
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     */
    public function getLastWeekFirstDay(int $offset = 0,String $formatStr = 'Y-m-d H:i:s'){
        $currentWeekNum = date('w');
        $dataTime = new \DateTime(date('Y-m-d H:i:s',time()));
        $dataInterval = new \DateInterval('P1W');
        return $dataTime->sub($dataInterval)
            ->sub(new \DateInterval('P' . $currentWeekNum . 'D'))
            ->add(new \DateInterval('P' . $offset . 'D'))
            ->format($formatStr);
    }

    /**
     * 获取两个时间之间的间隔
     * @param String $startTime 开始时间
     * @param String $endTime 结束时间
     * @param string $unit 时间间隔单位 [day|month|year]
     * @return Integer
     */
    public function getDateTimeInterval($startTime,$endTime,$unit = 'day'){
        $unitMap = [
            'day'   =>  'a',
            'month' =>  'm',
            'year'  =>  'y',
        ];
        $endDateTimeObj = new \DateTime($endTime);
        $interval = (new \DateTime($startTime))
            ->diff($endDateTimeObj)
            ->format('%R,%' . $unitMap[$unit]);
        list($operator,$count) = explode(',',$interval);
        if($operator == '+'){
            return $count;      // 返回正数
        }
        return $operator . $count;      // 返回负数
    }

    /**
     * 时间加减运算
     * @param String $dateTime 参与计算的时间
     * @param String $operator 操作符 [+/-] default +
     * @param Integer $year 年份 default 0
     * @param Integer $month 月份 default 0
     * @param Integer $day 天数 default 0
     * @param Integer $hour 小时 default 0
     * @param Integer $minute 分钟 default 0
     * @param Integer $seconds 秒钟 default 0
     * @param String $formatStr 格式字符串 default 'Y-m-d H:i:s'
     * @return string
     */
    public function compute($dateTime,$operator = '+',
                $year = 0,$month = 0,$day = 0,$hour = 0,$minute = 0,$seconds = 0,$formatStr = 'Y-m-d H:i:s'){
        $intervalSpec = 'P' . $year . 'Y' . $month . 'M' . $day . 'DT' . $hour . 'H' . $minute . 'M' . $seconds . 'S';
        if($operator == '+'){
            return (new \DateTime($dateTime))
                ->add(new \DateInterval($intervalSpec))
                ->format($formatStr);
        }
        return (new \DateTime($dateTime))
            ->sub(new \DateInterval($intervalSpec))
            ->format($formatStr);
    }
}