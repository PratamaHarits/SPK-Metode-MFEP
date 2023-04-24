<?php
// koneksi
include '../tools/connection.php';

// header
include '../blade/header.php';
?>

<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">

        <!-- kop surat -->
        <p class="text-center fw-bold m-0">PEMERINTAH KOTA PADANG</p>
        <p class="text-center fw-bold m-0">DINAS KOPERASI, USAHA KECIL DAN MENENGAH</p>
        <p class="text-center m-0">Jl. Ujung Gurun No. 3 Kota Padang Telepon (0751) 21355</p>
        <p class="text-center m-0">Email : diskoperasiukm@padang.go.id</p>
        <hr>

        <!-- isi surat -->
        <p class="text-center fw-bold">Laporan Perangkingan Penerima Bantuan Usaha Mikro Kecil dan Menengah (UMKM)</p>
        <p class="text-justify">Berdasarkan hasil pengolahan data dengan menggunakan beberapa kriteria yang sudah ditentukan dan dengan mengimplementasikan metode Multifactor Evaluation Process (MFEP), maka menghasilkan tiga rangking teratas sebagai berikut : </p>

        <?php $ranks = array(); ?>

        <!-- <div class="row">
            <div class="col">
                <p class="text-center fw-bold">Tabel Nilai Weight Evaluation</p>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-info">
                            <th rowspan="2">No</th>
                            <th rowspan="2">Nama Alternatif</th>
                            <?php
                            $data = $conn->query("SELECT * FROM ta_kriteria");
                            $kriteriaRows = mysqli_num_rows($data);
                            ?>
                            <th colspan="<?= $kriteriaRows; ?>">Nama Kriteria</th>
                            <th rowspan="2">Nilai MFEP</th>

                        </tr>
                        <tr class="table-info">
                            <?php
                            $data = $conn->query("SELECT * FROM ta_kriteria");
                            while ($kriteria = $data->fetch_assoc()) { ?>
                                <td><?= $kriteria['kriteria_nama']; ?></td>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_kode");
                        $no = 1;
                        while ($alternatif = $data->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $alternatif['alternatif_nama'] ?></td>
                                <?php $hasilSum = 0; ?>
                                <?php
                                $alternatifKode = $alternatif['alternatif_kode'];
                                $sql = $conn->query("SELECT * FROM tb_nilai WHERE alternatif_kode='$alternatifKode' ORDER BY kriteria_kode");
                                while ($data_nilai = $sql->fetch_assoc()) { ?>

                                    <?php
                                    $kriteriaKode = $data_nilai['kriteria_kode'];
                                    $sqli = $conn->query("SELECT * FROM ta_kriteria WHERE kriteria_kode='$kriteriaKode' ORDER BY kriteria_kode");
                                    while ($kriteria = $sqli->fetch_assoc()) { ?>

                                        <?php
                                        $bobot = $conn->query("SELECT * FROM ta_kriteria WHERE kriteria_kode='$kriteriaKode' ORDER BY kriteria_kode");
                                        $kriteria_bobot = $bobot->fetch_assoc();
                                        ?>

                                        <?php

                                        $hasil = $data_nilai['nilai_faktor'] * $kriteria_bobot['kriteria_bobot'];

                                        $hasilSum = $hasilSum + $hasil;
                                        ?>

                                        <td><?= number_format($hasil, 2); ?></td>
                                    <?php } ?>
                                <?php } ?>

                                <td><?= number_format($hasilSum, 2); ?></td>

                                <?php
                                $rank['hasilSum'] = $hasilSum;
                                $rank['alternatifNama'] = $alternatif['alternatif_nama'];
                                $rank['alternatifKode'] = $alternatif['alternatif_kode'];
                                array_push($ranks, $rank);
                                ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div> -->

        <div class="row mt-3">
            <div class="col-1"></div>
            <div class="col-10">
                <!-- <p class="text-center fw-bold">Tabel Ranking</p> -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ranking</th>
                            <th>Kode Alternatif</th>
                            <th>Nama Alternatif</th>
                            <th>Nilai MFEP</th>
                            <th>Keputusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ranking = 1;
                        rsort($ranks);
                        foreach ($ranks as $r) {
                        ?>
                            <tr>
                                <td><?= $ranking++; ?></td>
                                <td><?= $r['alternatifKode']; ?></td>
                                <td><?= $r['alternatifNama']; ?></td>
                                <td><?= number_format($r['hasilSum'], 2); ?></td>
                                <td><?= ($ranking <= 4) ? 'Direkomendasikan' : 'Tidak Direkomendasikan'; ?></td>
                            </tr>
                        <?php
                            //jika hanya menampilkan 3 nilai teratas
                            if ($ranking > 3) {
                                break;
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-1"></div>
        </div>

        <p class="text-justify">Demikian surat ini kami sampaikan atas perhatian bapak / ibu / saudara, kami ucapkan terimakasih</p>

        <br><br>

        <p style=" text-align: right;">Padang, <?php echo date("d/m/Y") ?></p><br><br>
        <p style=" text-align: right;">Dinas Koperasi dan Umkm </p>

    </div>
    <div class="col-lg-1"></div>
</div>

<script>
    window.print();
</script>