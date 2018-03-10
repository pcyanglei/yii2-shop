<?php
namespace common\components\task;
use \SplQueue;
use \Generator;

class Scheduler
{
    protected $maxTaskId = 0;
    protected $taskMap = [];
    protected $taskQueue;
    
    public function __construct()
    {
        $this->taskQueue = new SplQueue();
    }
    /**
     * 添加新的任务到调度器队列
     * @param unknown $coroutine
     */
    public function newTask(Generator $coroutine)
    {
        $tid = ++$this->maxTaskId;
        $task = new task($tid, $coroutine);
        $this->taskMap[$tid] = $task;
        $this->schedule($task);
        return $tid;
    }
    
    public function schedule(Task $task)
    {
        $this->taskQueue->enqueue($task);
    }
    
    
    public function run()
    {
        while (!$this->taskQueue->isEmpty()) 
        {
            /*@var Task $task */
            $task = $this->taskQueue->dequeue();
            $retval = $task->run();
            //如果迭代器返回的值是系统级别的 就直接回调这个系统方法 传递当前task对象 和 调度器对象
            if ($retval instanceof SystemCall) {
                $retval($task,$this);
                continue;
            }
            
            if ($task->isFinished()) {
                unset($this->taskMap[$task->getTaskId()]);
            }else{
                $this->schedule($task);
            }
        }
    }
    
    
}