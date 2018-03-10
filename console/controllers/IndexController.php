<?php
namespace console\controllers;
use yii\console\Controller;
use common\components\task\Scheduler;
use common\components\task\SystemCall;
use common\components\task\Task;

class IndexController extends Controller
{
    
    public function actionTest()
    {
        function gen() {
            echo 1 . "\n";
            $ret = (yield 'yield1');
            echo 2 . "\n";
            var_dump($ret);
            $ret = (yield 'yield2');
            echo 3 . "\n";
            var_dump($ret);
        }
        
        $gen = gen();//执行这里的时候 上面的代码就被隐式的调用了 rewind()
        var_dump($gen->current());    // 获取当前的yield 并执行
        var_dump($gen->send('ret1')); // 获取下一个
        var_dump($gen->send('ret2')); //
    }
    
    
    public function actionIndex2()
    {
        function getTaskId() {
            return new SystemCall(function(Task $task, Scheduler $scheduler) {
                //这里就是把当前系统调动的task 设置下次掉用他需要发送的value字段
                $task->setSendValue($task->getTaskId());
                //吧系统调用的task放入队列
                $scheduler->schedule($task);
            });
        }
        
        function task($max) {
            $tid = (yield getTaskId()); // <-- here's the syscall!
            for ($i = 1; $i <= $max; ++$i) {
                echo "This is task $tid iteration $i.\n";
                yield;
            }
        }
        
        $scheduler = new Scheduler;
        
        $scheduler->newTask(task(10));
//         $scheduler->newTask(task(5));
        
        $scheduler->run();
        
    }
    
    public function actionIndex()
    {
        function task1() {
            for ($i = 1; $i <= 10; ++$i) {
                echo "This is task 1 iteration $i.\n";
                yield $i;
            }
        }
         
        function task2() {
            for ($i = 1; $i <= 5; ++$i) {
                echo "This is task 2 iteration $i.\n";
                yield;
            }
        }
        
         
        $scheduler = new Scheduler();
         
        $scheduler->newTask(task1());
        $scheduler->newTask(task2());
         
        $scheduler->run();
    }
}