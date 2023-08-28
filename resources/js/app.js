import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import DataTable from 'datatables.net-dt';
import 'datatables.net-dt/css/jquery.dataTables.css';
import $ from "jquery";

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
                        return `<a href="/invoice/${data}" class="">Lihat</a>`;
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
                        return `<a href="/kwitansi/${data}" class="">Lihat</a>`;
                    }
                }
            ]
        });
    } else if (window.location.pathname === '/format/buat-dokumen'){
    $('#addbtn').on('click',function(){

        // Get the container
        const container = document.getElementById('patternContainer');

        // Create a new pattern
        const pattern = document.createElement('div');
        pattern.innerHTML = `
            <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="name_form[]" id="name_form" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="name_form" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama</label>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="pattern[]" id="pettern_doc" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="pettern_doc" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Value
                    Pattern<label>
            </div>
            </div>
        `;

        // Append the new pattern to the container
        container.appendChild(pattern);
    });
    $('#rmvbtn').on('click',function(){
        // Get the container
        const container = document.getElementById('patternContainer');

        // Remove the last pattern if it exists
        if (container.lastChild) {
            container.removeChild(container.lastChild);
        }
    });
    }


    
});

