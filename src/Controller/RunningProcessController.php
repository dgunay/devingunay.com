<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RunningProcessController extends AbstractController
{
  // Shows minecraft BE server info/uptime
  // TODO: use Symfony\Process instead of exec
  public function mineCraft()
  {
    // Get minecraft process info
    $minecraft = $this->runProcess("ps aux | grep -vP 'SCREEN|grep' | grep minecraftbe");
    if ($minecraft === null) {
      // TODO: return nothing
    }

    /*
    // TODO: figure out easy way to find process uptime and pretty print it
    // Transform it into an associative array
    $keys = ['user', 'pid', 'cpu', 'mem', 'vsz', 'rss', 'tty', 'stat', 'start', 'time', ];
    $minecraft = array_combine($keys, $process);

    // Get the running time as a nice looking string
    $proc_uptime = $this->runProcess("ps -o etimes= -p {$minecraft['pid']}");
    $uptime = null;
    if (preg_match('/(\d+)/', $proc_uptime[0], $match)) {
      $uptime = (new DateInterval("PT{$match[1]}"))->format('%d days, %h:%I hours');
    }
    
    return $this->render('minecraft_uptime.html.twig');
    */
    
    return $this->render('minecraft_uptime.html.twig', ['server' => $minecraft]);
  }

  protected function runProcess(string $cmd):?array {
    exec($cmd, $output);
    $process = null;
    if (!empty($output)) {    
    	$process = preg_split('/\s+/', $output[0]);
    }
    
    return $process;
  }

}
