import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import DataTable from 'datatables.net-dt';
import 'datatables.net-dt/css/jquery.dataTables.css';

document.addEventListener('DOMContentLoaded', function () {
    if (window.location.pathname === '/dashboard') {
        const apiInvoicesUrl = document.getElementById('api-invoices-url').dataset.url;

        const tblInvoice = new DataTable('#tbl-invoice', {
            processing: true,
            serverSide: true,
            ajax: apiInvoicesUrl,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'invoice_id', name: 'invoice_id' },
                { data: 'nama_client', name: 'nama_client' },
                { data: 'created_at', name: 'created_at' },
                // ... tambahkan kolom lainnya sesuai kebutuhan
                {
                    data: 'id',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `<a href="${data}" class="">Lihat</a>`;
                    }
                }
            ]
        });

        const apiKwitansiUrl = document.getElementById('api-kwitansi-url').dataset.url;

        const tblKwitansi = new DataTable('#tbl-kwitansi', {
            processing: true,
            serverSide: true,
            ajax: apiKwitansiUrl,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'kwitansi_id', name: 'kwitansi_id' },
                { data: 'invoice_id', name: 'invoice_id' },
                { data: 'project_id', name: 'project_id' },
                {
                    data: 'id',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `<a href="${data}" class="">Lihat</a>`;
                    }
                }
            ]
        });
    }
});

