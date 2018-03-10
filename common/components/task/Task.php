<?php
namespace common\components\task;
use \Generator;

class Task
{
    protected $taskId;
    protected $coroutine;
    //给协程发送的消息内容
    protected $sendValue = NULL;
    
    protected $beforFirstYield = true;
    
    
    public function __construct($taskId,Generator $coroutine)
    {
        $this->taskId = $taskId;
        $this->coroutine = $coroutine;
    }
    
    public function run()
    {
        if ($this->beforFirstYield == true) {
            $this->beforFirstYield = false;
            return $this->coroutine->current();
        }else{
            $retval = $this->coroutine->send($this->sendValue);
            $this->sendValue = null;
            return $retval;
        }
    }
    
    public function isFinished()
    {
        return !$this->coroutine->valid();
    }
    
    public function setSendValue($value)
    {
        $this->sendValue = $value;
    }
    
    public function getTaskId()
    {
        return $this->taskId;
    }
    
}