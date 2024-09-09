<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    ///Select record
    public function index()
    {
        try {

            $tasks = $this->getTasks()->get();
            return $this->responseMessage( $tasks, true, 200 );

        }catch (\Exception $e){
            $message = $e->getMessage();
            return  $this->responseMessage( $message, false, 500 );
        }
    }


    //Filter by staus

    public function filter( $status )
    {
        try {
            $tasks = $this->getTasks()
                ->where('tasks.completed','like','%'.$status.'%')->get();
            return $this->responseMessage( $tasks, true, 200 );

        }catch (\Exception $e){
            $message = $e->getMessage();
            return  $this->responseMessage( $message, false, 500 );
        }
    }

    // Crear tarea

    public function store(TaskRequest $request)
    {
        try {

            $user_id = User::where('email',$request['email'])->first()->id;
            $task =  Task::create([
                'title' => $request['title'],
                'description' => $request['description'],
                'user_id' =>  $user_id
            ]);

            $data = $this->getTaskById( $task->id );

            return $this->responseMessage( $data, true, 200 );

        }catch ( \Exception $e){
            $message = $e->getMessage();
            return  $this->responseMessage( $message, false, 500 );
        }

    }


    protected  function getTaskById( $task_id )
    {
       return Task::join('users','tasks.user_id','users.id')
            ->where('tasks.id',$task_id)
            ->select('users.name as user',
                'users.email',
                'tasks.id',
                'tasks.title',
                'tasks.description')
             ->get();
      }

      protected function getTasks()
      {
          return Task::join('users','tasks.user_id','users.id')
              ->select('users.name as user',
                  'users.email',
                  'tasks.title',
                  'tasks.id',
                  'tasks.completed',
                  'tasks.description');

      }

      protected function responseMessage( $message, $status, $code )
      {
          return response()->json([
              'response'     => $message,
              'status'      => $status,
              'code'        => $code,
          ]);
      }


      public function complete( Task $task )
      {
          try {
              $task->completed = 1;
              $task->save();
              return $this->responseMessage( 'Task completed', true, 200 );
          }catch (\Exception $e){
              $message = $e->getMessage();
              return  $this->responseMessage( $message, false, 500 );
          }
      }


    // Actualizar tarea
    public function update(TaskRequest $request,Task $task)
    {
        try {
            $task->update( $request->all() );
            return $this->responseMessage( 'Task updated successfully.', true, 200 );
        }catch (\Exception $e){
            $message = $e->getMessage();
            return  $this->responseMessage( $message, false, 500 );
        }

    }

    // Eliminar tarea
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return $this->responseMessage( 'Task deleted', true, 200 );

        }catch ( \Exception $e){
            $message = $e->getMessage();
            return  $this->responseMessage( $message, false, 500 );
        }
    }
}
