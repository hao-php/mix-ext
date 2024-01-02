<?php

namespace Haoa\Mixdb;

use Mix\Database\Connection;
use Mix\Database\Database;

class DB
{

    /**
     * 获取连接, 如果是在事物中, 会获取当前事物的连接
     * @return void
     */
    public static function getConn(Database $database): Connection|\Mix\Database\Database
    {
        /** @var $obj TransactionHelper */
        $obj = RunContext::instance()->get(RunContextKey::OBJ_TRANSACTION_HELPER);
        if (!empty($obj)) {
            return $obj->transaction;
        }
        return DB::instance();
    }

    public static function getTransaction(): ?TransactionHelper
    {
        /** @var $obj TransactionHelper */
        $obj = RunContext::instance()->get(RunContextKey::OBJ_TRANSACTION_HELPER);
        return $obj;
    }

    public static function beginTransaction()
    {
        /** @var $obj TransactionHelper */
        $obj = RunContext::instance()->get(RunContextKey::OBJ_TRANSACTION_HELPER);
        if (empty($obj)) {
            $obj = new TransactionHelper();
            $obj->addNum();
            RunContext::instance()->set(RunContextKey::OBJ_TRANSACTION_HELPER, $obj);
        } else {
            $obj->addNum();
        }
        return $obj;
    }

    public static function commit()
    {
        /** @var $obj TransactionHelper */
        $obj = RunContext::instance()->get(RunContextKey::OBJ_TRANSACTION_HELPER);
        if (empty($obj)) {
            throw new \Exception('未获取到事物对象');
        }
        $obj->commit();
    }

    public static function rollback()
    {
        /** @var $obj TransactionHelper */
        $obj = RunContext::instance()->get(RunContextKey::OBJ_TRANSACTION_HELPER);
        if (empty($obj)) {
            throw new \Exception('未获取到事物对象');
        }
        $obj->rollback();
    }

}