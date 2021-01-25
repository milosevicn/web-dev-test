<?php

namespace App\Mailers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AppMailer {

    public function sendTo($to, $subject, $view, $data = []) {
        $factory = app(Factory::class);

        $template = file_get_contents($factory->getFinder()->find($view));
        $content = $this->renderTemplate($template, $data);
        $content = trim(str_replace('<br />', '', $content['text']));
        Mail::html($content, function($message) use ($to, $subject) {
            $message->setSubject($subject);
            $message->addTo($to);
        });
    }

    public function renderTemplate($template, $data = []) {
        $factory = app(Factory::class);

        $template = nl2br($template);
        $path = storage_path(md5(microtime())).'.blade.php';
        $tempView = fopen($path, 'w');
        fwrite($tempView, $template);
        fclose($tempView);
        
        $view = new View($factory, $factory->getEngineFromPath($path), '', $path, $data);
        $message = [
            'text' => $view->render(),
            'sections' => $view->renderSections(),
        ];
        
        if(file_exists($path)) {
            unlink($path);
        }
        return $message;
    }

}