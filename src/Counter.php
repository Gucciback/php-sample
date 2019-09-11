<?php

namespace some;


class Counter
{
    private $limit = 1000;
    private $domains = [];
    private $db;
    private $current = 0;

    public function __construct(\some\Mysql $db)
    {
        $this->db = $db;
        foreach($this->fetch() as $portion){
            $this->count($portion);
        }
    }

    private function fetch()
    {
        do {
            $q = $this->db->prepare('SELECT `email` FROM users LIMIT :current, :limit');
            $q->bindValue(':current', $this->current, \PDO::PARAM_INT);
            $q->bindValue(':limit', $this->limit, \PDO::PARAM_INT);
            $q->execute();
            $c = $q->rowCount();
            $this->current+=$c;
            yield ['count' => $c, 'data'=> $q->fetchAll(\PDO::FETCH_ASSOC)];
        }
        while(/*$this->current < 10*/$c === $this->limit);
    }

    private function count($d)
    {
        foreach($d['data'] as $row){
            if($row['email'] !== ''){
                foreach($this->retrieveDomains($row['email']) as $domain){
                    if(!isset($this->domains[$domain]))
                        $this->domains[$domain] = 1;
                    else
                        ++$this->domains[$domain];
                }
            }
        }
    }

    private function retrieveDomains($str)
    {
        /*
         * на таком количестве данных любое регулярное выражение будет проигрывать в скорости выполнения
         * */
        $tmp = [];
        foreach(explode(',',$str) as $email)
        {
            $spl = explode('@', $email);
            $tmp[] = $spl[1];
        }
        return $tmp;
    }

    public function getResults()
    {
        return $this->domains;
    }
}