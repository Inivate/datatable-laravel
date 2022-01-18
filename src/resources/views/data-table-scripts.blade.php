
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/datatable/css/rowGroup.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.9/css/dataTables.checkboxes.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/datatables.checkboxes.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.rowGroup.min.js') }}"></script>
@foreach ($dataTables as $dataTable)
    <script>        
            $(function () {
                'use strict';

                var dataTable = $('#id').dataTable();
                var {{ $dataTable['id'] }} = $('#{{ $dataTable['id'] }}').DataTable({
                    ajax: {
                        url: "{{ route('datatable.api') }}",
                        "data": {
                            "dummy": false,
                            "model": '{{ $dataTable['model'] }}',
                            "resource": '{{ $dataTable['resource'] }}',
                            @isset($dataTable['model_where'])
                                "model_where": '{{ $dataTable['model_where'] }}',
                            @endisset
                        },
                        error: function (result) {
                            $('#{{ $dataTable['id'] }}_processing').css("display", "none");
                        }
                    },
                    deferRender: true,
                    columns: [
                        @foreach ($dataTable['table']['columns'] as $column)
                            { 
                                name: '{{ @$column['name'] }}', 
                                data: '{{ @$column['data'] }}', 
                                searchable: '{{ @$column['searchable'] }}' 
                            },
                        @endforeach
                    ],
                    processing: true,
                    serverSide: true,
                    columnDefs:[
                        @foreach ($dataTable['table']['columns'] as $index => $column)
                            @if($column['orderable'] == 'false' ) 
                                {targets: {{ $index }}, orderable : false},
                            @endif
                        @endforeach
                    ],

                    select:{
                        style: 'multi',
                        selector: 'td:first-child',
                        className: 'selected',
                    },
                    @isset($dataTable['table']['defaultOrder'])
                        order: [[{{ $dataTable['table']['defaultOrder']['column'] }}, '{{ $dataTable['table']['defaultOrder']['sortBy'] }}' ]],
                    @endisset
                    dom:
                        '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-8"<"action-section">li><"col-sm-12 col-md-4"fp>>tr<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    @isset($dataTable['table']['displayLength'])
                        displayLength: {{ $dataTable['table']['displayLength'] }},
                    @else
                        displayLength: 50,
                    @endisset
                    lengthMenu: [ [10, 25, 50, 100, 250, 500, 1000], [10, 25, 50, 100, 250, 500, 1000] ],
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal(),
                            type: 'column',
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                tableClass: 'table'
                            })
                        }
                    },
                    language: {
                        paginate: {
                            previous: '&nbsp;',
                            next: '&nbsp;'
                        },
                        "processing": '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>'
                    },
                });
                $(document).on('reload-data-table', function(event) {
                    {{ $dataTable['id'] }}.ajax.reload();
                });
            });
    </script>
@endforeach