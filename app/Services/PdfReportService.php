<?php
namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class PdfReportService
{
    public function gerar(array $dados): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        

        $html = View::make('pdf.relatorio', $dados)->render();

        $data_inicial = Carbon::parse($dados['dataInicio'])->format('d-m-Y');
        $data_fim = Carbon::parse($dados['dataFim'])->format('d-m-Y');

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $fileName = 'Relatorio_Mensal_' .$data_inicial . '_A_'. $data_fim . '.pdf';
        return $dompdf->stream($fileName);
    }
}
