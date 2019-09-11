<?php

namespace some;

class Dummy
{
    private $domains = [
        'jela.com',
        'tesa.com',
        'yuppa.ru',
        'gossa.net',
        'yetssa.ru',
        'kemps.com'
    ];

    private $domains_count = 0;

    private  $dummy = [];

    private function __construct()
    {
        $this->domains_count = count($this->domains) - 1;
        $this->dummy = ['name' => $this->generate_name(), 'gender' => $this->generate_gender(), 'email' => $this->generate_emails()];
    }

    public function getObj(){
        return $this->dummy;
    }

    public static function generate($count)
    {
        for($i = 0; $i < $count; $i++)
            yield new self();
    }

    private function random_string($minl = 5, $maxl = 32)
    {
        return substr(md5(mt_rand(10000,99999)), 0, mt_rand($minl,$maxl));
    }

    private function generate_name()
    {
        return $this->random_string();
    }

    private function generate_gender()
    {
        return mt_rand(1,2);
    }

    private function generate_emails()
    {
        $emails = [];
        shuffle($this->domains);
        foreach ($this->domains as $domain) {
            $emails[] = $this->random_string(5,10).'@'.$domain;
        }
        return implode(',', array_slice($emails, 0, mt_rand(0, $this->domains_count)));
    }
}