<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="float-start">
                                        <h3>HFC</h3>
                                    </div>
                                    <div class="float-end">
                                        <h4>Invoice <br>
                                            <!-- <strong><?= $data[0]->order_number; ?></strong> -->
                                        </h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="float-start mt-3">
                                            <address>
                                                <strong>To: <?= $data[0]->user_namalengkap; ?></strong><br>
                                                <?php
                                                $this->db->select('prov_name,city_name,dis_name,lengkap');
                                                $this->db->join('lokasi', 'lokasi.id_mitra = user.user_id', 'inner');
                                                $this->db->join('provinces', 'provinces.prov_id = lokasi.id_prop', 'inner');
                                                $this->db->join('cities', 'cities.city_id = lokasi.id_kab', 'inner');
                                                $this->db->join('districts', 'districts.dis_id = lokasi.id_kec', 'inner');
                                                $this->db->where('user_id', $data[0]->toko_id);
                                                $nama = $this->db->get('user')->row(); ?>
                                                <?= $nama->dis_name; ?><br>
                                                <?= $nama->city_name . ' ' . $nama->prov_name; ?><br>
                                                <abbr title="Phone">P:</abbr> (123) 456-7890
                                            </address>
                                        </div>
                                        <div class="float-end mt-3">
                                            <p><strong>Order Date: </strong> <?= $data[0]->last_update; ?></p>
                                            <p class="m-t-10"><strong>Kasir: </strong> <span class="label label-pink">HFC</span></p>
                                            <p class="m-t-10"><strong>Order ID: </strong> #<?= $data[0]->order_number; ?></p>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table mt-4">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Item</th>
                                                        <th>Description</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Cost</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 0;
                                                    $t_jml = [];
                                                    foreach ($data as $d) {
                                                        $t_jml[] = $d->jumlah * $d->toko;
                                                        $no++; ?>
                                                        <tr>
                                                            <td><?= $no; ?></td>
                                                            <td><?= $d->produk; ?></td>
                                                            <td><?= $d->description; ?></td>
                                                            <td><?= $d->jumlah; ?></td>
                                                            <td><?= format_rupiah($d->toko); ?></td>
                                                            <td><?= format_rupiah($d->jumlah * $d->toko); ?></td>
                                                        </tr>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5 col-5">
                                        <div class="clearfix mt-4">
                                            <h5 class="small text-dark fw-normal">PAYMENT TERMS AND POLICIES</h5>

                                            <small>
                                                All accounts are to be paid within 7 days from receipt of
                                                invoice. To be paid by cheque or credit card or direct payment
                                                online. If account is not paid within 7 days the credits details
                                                supplied as confirmation of work undertaken will be charged the
                                                agreed quoted fee noted above.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-7 offset-xl-3">
                                        <div class="row">
                                            <div class="col-5"><b>Sub-total:</b></div>
                                            <div class="col-2"><b>Rp</b></div>
                                            <div class="col-5"><b><?= format_rupiah(array_sum($t_jml)); ?></b></div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-5">Bayar:</div>
                                            <div class="col-2">Rp</div>
                                            <div class="col-5"><?= format_rupiah($d->bayar); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5">Kembali:</div>
                                            <div class="col-2">Rp</div>
                                            <div class="col-5"><?= format_rupiah($d->bayar - array_sum($t_jml)); ?></div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-print-none">
                                <div class="float-end">
                                    <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light"><i class="fa fa-print"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->

</div> <!-- content -->

<!-- Footer Start -->

<!-- end Footer -->

</div>