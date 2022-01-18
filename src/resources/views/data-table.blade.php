@php
    if (!isset($dataTabbleId)) {
        $dataTabbleId = 0;
    }
@endphp
<table id="{{ $dataTables[$dataTabbleId]['id'] }}" class="dt-row-grouping table">
    @isset ($dataTables[$dataTabbleId]['table']['columns'])
        <thead>
            <tr>
                @foreach ($dataTables[$dataTabbleId]['table']['columns'] as $column)
                    @if (array_key_exists('label', $column))
                        <th>{{ $column['label'] }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
    @endisset
</table>
