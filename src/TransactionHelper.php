<?php

namespace App\Lib\App\Db;

use App\Constant\RunContextKey;
use App\Container\RunContext;
use App\Container\DB;
use Mix\Database\Transaction;

class TransactionHelper
{

    public Transaction $transaction;

    private int $beginNum = 0;

    public $commitEvents = [];

    public function __construct()
    {
        $this->transaction = DB::instance()->beginTransaction();
    }

    public function addNum()
    {
        $this->beginNum++;
    }

    public function addCommitEvent($event)
    {
        $this->commitEvents[] = $event;
    }

    public function commit()
    {
        $this->beginNum--;
        if ($this->beginNum > 0) {
            return;
        }
        RunContext::instance()->delete(RunContextKey::OBJ_TRANSACTION_HELPER);
        $this->transaction->commit();

    }

    public function rollback()
    {
        $this->beginNum--;
        if ($this->beginNum > 0) {
            return;
        }
        RunContext::instance()->delete(RunContextKey::OBJ_TRANSACTION_HELPER);
        $this->transaction->rollback();
    }

}