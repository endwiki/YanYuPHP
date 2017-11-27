# 查看最后一条ID
select id from english_sentences order by id desc limit 1;

# 设置单词例句标志
update word set has_sentences = 1 where 1=1;

# 重复的单词
select word_id from word GROUP BY english HAVING count(*) > 1;