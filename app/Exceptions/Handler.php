<?php
namespace App\Exceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exception;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {   
        $this->renderable(function ( Exception $exception) {

            if(get_class($exception) == "Illuminate\\Http\\Exceptions\\ThrottleRequestsException"){
                return response()->json([
                
                    'message' => $exception->getMessage()
                    
    
                ],429);
            }

            elseif(get_class($exception) == "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"){
                return response()->json([
                
                    'message' => "API resource not found"
                    
    
                ],404);
            }
            
            else{

                return response()->json([
                
                    'type' => get_class($exception),
                     'message' => $exception->getMessage()
                    
                ],405);
            }


                //! Error Type Getter
                // return response()->json([
                //     'type' => get_class($exception),
                //     'message' => $exception->getMessage()
                // ]);

           
        });
       
    }

    
}