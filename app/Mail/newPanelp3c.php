<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class newPanelp3c extends Mailable
{
    public $id;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        //
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data=DB::table('pn_01_p3c')
        ->where('id',$this->id)
        ->limit(1)->orderByDesc('created_at')->first();
        $nama_proyek = $data->nama_proyek;
        $subject=$nama_proyek;

        $link='http://116.197.128.230/panel/produksi/create/'.$data->id.'';
        $linkEng='http://116.197.128.230/panel/eng/create/'.$data->id.'';
        return $this->subject($subject)
        ->markdown('emails.sites.newPanelp3c', [
            'nomor_seri_panel' => $data->nomor_seri_panel,
            'nama_customer' => $data->nama_customer,
            'nama_proyek' => $data->nama_proyek,
            'nomor_wo' => $data->nomor_wo,
            'nama_panel' => $data->nama_panel,
            'cell' => $data->cell,
            'deadline_produksi' => $data->deadline_produksi,
            'deadline_qc_pass' => $data->deadline_qc_pass,
            'status_pekerjaan' => $data->status_pekerjaan,
            'jenis_panel' => $data->jenis_panel,
            'jenis_tegangan' => $data->jenis_tegangan,
            'tipe_panel' => $data->tipe_panel,
            'panel_status' => $data->panel_status,
            'created_at' => $data->created_at,
            'admin' => $data->admin,
            'link' => $link,
            'linkEng' => $linkEng,
        ]);
    }
}
