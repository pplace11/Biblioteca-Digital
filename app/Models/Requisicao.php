<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// Modelo que representa uma requisicao de livro feita por um utilizador.
// O soft delete e usado para manter o historico de requisicoes encerradas.
class Requisicao extends Model
{
    use SoftDeletes;

    protected $table = 'requisicoes';

    protected $fillable = [
        'user_id',
        'livro_id',
        'numero_requisicao_seq',
        'cidadao_nome',
        'cidadao_email',
        'cidadao_numero_leitor',
        'cidadao_foto_path',
        'data_fim_prevista',
        'lembrete_devolucao_enviado_em',
        'devolucao_solicitada_em',
        'data_recepcao_real',
        'dias_decorridos',
        'confirmado_por_admin_id',
    ];

    protected $appends = [
        'cidadao_foto_url',
        'numero_requisicao',
    ];

    protected $casts = [
        'numero_requisicao_seq' => 'integer',
        'data_fim_prevista' => 'datetime',
        'lembrete_devolucao_enviado_em' => 'datetime',
        'devolucao_solicitada_em' => 'datetime',
        'data_recepcao_real' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Requisicao $requisicao) {
            if (empty($requisicao->numero_requisicao_seq)) {
                $requisicao->numero_requisicao_seq = static::proximoNumeroRequisicaoSequencial();
            }
        });
    }

    protected static function proximoNumeroRequisicaoSequencial(): int
    {
        return DB::transaction(function () {
            return ((int) DB::table('requisicoes')->lockForUpdate()->max('numero_requisicao_seq')) + 1;
        }, 3);
    }

    public function getNumeroRequisicaoAttribute(): ?string
    {
        if (is_null($this->numero_requisicao_seq)) {
            return null;
        }

        return sprintf('R%06d', (int) $this->numero_requisicao_seq);
    }

    // Relacao N:1 com o utilizador que fez a requisicao.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacao N:1 com o livro requisitado.
    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    // Obtem o URL da foto registada no momento da requisicao.
    public function getCidadaoFotoUrlAttribute(): string
    {
        if ($this->user?->profile_photo_url) {
            return $this->user->profile_photo_url;
        }

        if (!empty($this->cidadao_foto_path)) {
            return Storage::url($this->cidadao_foto_path);
        }

        $iniciais = trim((string) collect(explode(' ', (string) ($this->cidadao_nome ?: 'Cidadao')))
            ->filter()
            ->take(2)
            ->map(fn ($parte) => mb_substr($parte, 0, 1))
            ->implode(''));

        $svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 80 80'><rect width='80' height='80' fill='#E5E7EB'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-family='Arial, sans-serif' font-size='28' fill='#111111'>" . e($iniciais ?: 'C') . "</text></svg>";

        return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
    }
}



