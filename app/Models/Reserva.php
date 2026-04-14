<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    // Dizemos ao Laravel para usar a tua tabela existente do backup
    protected $table = 'reservas';

    // Como a tua tabela não tem as colunas 'created_at' e 'updated_at', avisamos aqui:
    public $timestamps = false;
}