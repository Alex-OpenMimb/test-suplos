<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(  )
    {
        try {
            $query = '';
            $tasks = $this->getTasks( $query );
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

            $user_id = User::where('email',$request['user'])->first()->id;
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
                'tasks.title',
                'tasks.description')
             ->get();
      }

      protected function getTasks( $query )
      {
          return Task::join('users','tasks.user_id','users.id')
              ->orWhere('tasks.completed','like','%'.$query.'%')
              ->select('users.name as user',
                  'tasks.title',
                  'tasks.id',
                  'tasks.completed',
                  'tasks.description')
              ->get();
      }

      protected function responseMessage( $message, $status, $code )
      {
          return response()->json([
              'response'     => $message,
              'status'      => $status,
              'code'        => $code,
          ]);
      }


    // Actualizar tarea
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:500',
        ]);

        $task = Task::find($id);

        if(!$task) {
            return redirect()->back()->with('error', 'Task not found.');
        }

        // Corrección: Se actualiza la tarea con datos validados.
        $task->update($validated);
        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    // Eliminar tarea
    public function destroy($id)
    {
        $task = Task::find($id);

        if(!$task) {
            return redirect()->back()->with('error', 'Task not found.');
        }

        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}
