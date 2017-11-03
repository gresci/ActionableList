<div class="responsive-table-container">
    <table class="table responsive-table">
        {{-- Column headers --}}
        <thead>
            <tr>
                {{-- Prints all the column headers --}}
                @foreach($table->columns as $column)
                    {{-- If this column only has actions, don't print a header --}}
                    @if ($column->hasActions === true)
                        <th class="col-button">
                            &nbsp;
                        </th>
                    {{-- If this column has content, print the header --}}
                    @else
                        <th class="col-testo">
                            {{ $column->name ?? '' }}

                            {{-- If this column has a name for sorting its content, then print the arrows --}}
                            @if ($column->sortableName !== '')
                                <span class="orderbuttons">
                                    <a href="?{{ http_build_query(array_merge(request()->query(), ['col' => $column->sortableName, 'ord' => 'asc'])) }}" class="dropup">
                                        <span class="caret"></span>
                                    </a>
                                </span>
                                <span class="orderbuttons">
                                    <a href="?{{ http_build_query(array_merge(request()->query(), ['col' => $column->sortableName, 'ord' => 'desc'])) }}" class="dropdown">
                                        <span class="caret"></span>
                                    </a>
                                </span>
                            @endif
                        </th>
                    @endif
                @endforeach
            </tr>
        </thead>

        {{--  Print the table content  --}}
        @foreach ($table->getRows() as $row)
            <tr>
                @foreach ($table->columns as $column)
                    @if ($column->hasActions)
                        <td class="col-button">
                    @else
                        <td>
                    @endif
                            {{ $column->getCellOutput($row) }}
                        </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>
