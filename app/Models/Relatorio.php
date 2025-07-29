<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Relatorio extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'nome',
        'data_inicial',
        'data_final',
        'caminho_arquivo',
        'status',
    ];

     public static function boot()
    {
        parent::boot();

       
        // Hook para gerar o nome antes de salvar o relatório
        static::creating(function ($relatorio) {
            if (empty($relatorio->nome)) {
                // Gerar o nome automaticamente
                $dataInicio = Carbon::parse($relatorio->data_inicial)->format('d-m-Y');
                $dataFim = Carbon::parse($relatorio->data_final)->format('d-m-Y');
                $relatorio->nome = 'relatorio_' . $dataInicio . '_a_' . $dataFim;
            }
        });
    }
         public function caminhoDownload()
    {
        return Storage::url($this->caminho_arquivo);  // Retorna o caminho do arquivo armazenado
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

