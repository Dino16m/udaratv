<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class makeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {serviceName : the name of service you want to create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'makes services';

    private $serviceDir; 
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->serviceDir = base_path('app/Services/');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    { 
        $serviceName = $this->argument('serviceName');
        $this->initDir();
        if(!$serviceName){
            return $this->error('the name is required');
        }
        if(!$this->makeFile($serviceName)){
            return $this->error('service '.$serviceName.' not created');
        }
        return $this->info('service '.$serviceName.'Service created');
    }

    private function makeFile($serviceName)
    {
        $dir = $this->serviceDir.$serviceName.'Service.php';
        $data = "<?php\nnamespace App\Services;\nclass ".$serviceName."Service\n{\n}";
        return file_put_contents($dir, $data);
    }

    private function initDir()
    {
        if(!is_dir($this->serviceDir)){
            return mkdir($this->serviceDir,0763) ? true : $this->error('the service directory does not exist and cannot be created');
        }
    }
}
