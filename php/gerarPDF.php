<?php

include './fpdf/fpdf.php';
//include './conexao.php';

$mysqli = new mysqli('localhost', 'root', '', 'flexpeak') or die(mysqli_error($mysqli));
$result = $mysqli->query("SELECT A.NOME AS NOME_ALUNO, C.NOME AS NOME_CURSO, P.NOME AS NOME_PROF 
        FROM ALUNO A
        INNER JOIN CURSO C ON A.ID_CURSO = C.ID_CURSO
        INNER JOIN PROFESSOR P ON C.ID_PROFESSOR = P.ID_PROFESSOR") or die($mysqli->error);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(150, 10, utf8_decode('Relatório de Alunos'), 0, 0, 'C');
$pdf->Ln(15);

$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(50, 7, 'Nome', 1, 0, 'C');
$pdf->Cell(50, 7, 'Curso', 1, 0, 'C');
$pdf->Cell(50, 7, 'Professor', 1, 0, 'C');
$pdf->Ln();

foreach ($result as $aluno) {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(50, 7, utf8_decode($aluno['NOME_ALUNO']), 1, 0, 'C');
    $pdf->Cell(50, 7, utf8_decode($aluno['NOME_CURSO']), 1, 0, 'C');
    $pdf->Cell(50, 7, utf8_decode($aluno['NOME_PROF']), 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();

