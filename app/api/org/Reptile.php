<?php
/**
 * 爬虫类
 * User: end_wiki
 * Date: 2017/11/29
 * Time: 16:41
 */
namespace app\api\org;

class Reptile {
    /**
     * 从有道词典获取单词例句
     */
    public function getExampleSentencesForYouDaoDict(){
        $db = Database::getInstance('MYSQL');
        $otherArgs = '&keyfrom=deskdict.main&dogVersion=1.0&dogui=json&client=deskdict&id=c489672309d53d4dd&vendor=webdict_default&in=YoudaoDict_webdict_default&appVer=7.5.1.0&appZengqiang=0&abTest=&le=en&dicts=%7B%22count%22%3A1%2C%22dicts%22%3A%5B%5B%22blng_sents%22%5D%5D%7D&LTH=31';

        $result = $db->table('word')
            ->field(['english'])
            ->where([
                'word_id'   =>  ['gt',0],
                'has_sentences' =>  ['lt',0],
            ])->fetch();
        foreach($result as $rowIndex => $row){
            $insertData = [];
            $url = 'http://dict.youdao.com/jsonapi?jsonversion=2&q=' .  urlencode($row['english']) . $otherArgs;
            $response = Request::sendGetRequest($url);
            $dataList = json_decode($response,true);
            // 查无结果，则跳过
            if(!isset($dataList['blng_sents']['sentence-pair'])){
                continue;
            }
            foreach($dataList['blng_sents']['sentence-pair'] as $item => $value ){
                $insertData[$item]['translate'] = $value['sentence'];
                $insertData[$item]['sentence'] = $value['sentence-translation'];
                $insertData[$item]['source'] = $value['url'];
                $db->table('english_sentences')->add($insertData[$item]);
            }
        }

        //$db->table('english_sentences')->addAll($insertData);

    }

    /**
     * 从柯林斯网站获取单词发音
     */
    public function getSoundForCollins(){
        $baseUrl = 'https://www.collinsdictionary.com/dictionary/english/';
        $databaseInstance = Database::getInstance('MYSQL');
        $i = 0;
        while($i < 18800){
            $i++;
            $dataList = $databaseInstance->table('word')
                ->field(['word_id','english'])
                ->where([
                    'word_id'   =>  ['gt',0],
                    'volume'    =>  ['eq','']
                ])->limit(1)->fetch();
            $response = Request::sendGetRequest($baseUrl . $dataList['english']);

            if(!$response){
                $result = $databaseInstance->table('word')
                    ->where([
                        'word_id'   =>  $dataList['word_id']
                    ])->update([
                        'volume'    =>  'The Null'
                    ]);
            }else{
                if(preg_match('$(https://)(.*?)[0-9]{5}(.mp3)$',$response,$wordVolume)){
                    if(isset($wordVolume[0])  && is_string($wordVolume[0])){
                        $volume = $wordVolume[0];
                    }else{
                        $volume = '单词错误';
                    }
                    if(empty($volume)){
                        $volume = '单词错误';
                    }
                    $result = $databaseInstance->table('word')
                        ->where([
                            'word_id'   =>  $dataList['word_id']
                        ])->update([
                            'volume'    =>  $volume
                        ]);
                }
            }
            // die();
        }

    }

    /**
     * 从有道词典获取单词信息
     */
    public function getWordInfoForYouDaoDict(){

    }

    /**
     * 从 ICBA 网站获取翻译信息
     */
    public function getWordTranslateFromICBA(){
        $baseUrl = 'http://fy.iciba.com/ajax.php?a=fy';
        $db = Database::getInstance('MYSQL');
        $i = 0;

        while($i < 27712){

            $word = $db->table('word')
                ->field(['word_id','english'])
                ->where([
                    'chinese'   =>  ['eq','NUL']
                ])->limit(1)->fetch();

            $response = Request::sendPostRequest($baseUrl,[
                'f' =>  'auto',
                't' =>  'auto',
                'w' =>  $word['english']
            ]);
            $result = json_decode($response,true);

            if($result && isset($result['content'])){
                if(isset($result['content']['ph_en_mp3']) && $result['content']['ph_en_mp3'] != ''){
                    $volume = $result['content']['ph_en_mp3'];
                }else{
                    if(isset($result['content']['ph_tts_mp3']) && $result['content']['ph_tts_mp3'] != ''){
                        $volume = $result['content']['ph_tts_mp3'];
                    }else{
                        $volume = 'NULL';
                    }
                }
                if(!isset($result['content']['out'])){
                    $result['content']['out'] = '';
                }
                $chinese = isset($result['content']['word_mean'][0]) ? $result['content']['word_mean'][0] :
                    $result['content']['out'];
                $flag = $db->table('word')
                    ->where([
                        'word_id'   =>  $word['word_id']
                    ])->update([
                        'chinese'   =>  $chinese,
                        'volume'    =>  $volume
                    ]);
                if(!$flag){
                    $db->table('word')
                        ->where([
                            'word_id'   =>  $word['word_id']
                        ])->update([
                            'chinese'   =>  'NULL',
                            'volume'    =>  'NULL'
                        ]);
                }
            }else{
                $db->table('word')
                    ->where([
                        'word_id'   =>  $word['word_id']
                    ])->update([
                        'chinese'   =>  'NULL',
                        'volume'    =>  'NULL'
                    ]);
            }
            // die();
        }
    }

    /**
     * 从 HTML 中获取指定标签内容
     * @param String $url Html 路径
     * @param String $tag Html 标签
     * @param String $attr 标签属性
     * @param String $value 标签属性值
     * @return string
     */
    public function getTagValueFromHtml(String $url,String $tag,String $attr,String $value) : string{
        $documentObject = new \DOMDocument('1.0','utf-8');
        $documentObject->preserveWhiteSpace = false;
        @$documentObject->loadHTMLFile($url);
        $htmlTags = $documentObject->getElementsByTagName($tag);
        foreach($htmlTags as $index => $htmlTag){
            if($htmlTag->getAttribute($attr) === $value){
                return $htmlTag->nodeValue;
            }
        }
    }
}