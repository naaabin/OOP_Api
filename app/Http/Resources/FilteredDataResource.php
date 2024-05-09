<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilteredDataResource extends JsonResource
{
    
    public function toArray($request)
    {
        
            return [
                'Task' => $this->task,
                'Description' => $this->description,
                'Priority' => $this->priority,
                'Files'  => $this->files->pluck('file_name')->implode(', '),
                'No of files' => $this->files->count(),
            ];
        

        
    }

}

