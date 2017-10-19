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

        {{-- Table contents --}}
        @foreach ($table->items as $item)
            <tr>
                {{-- For each column, print its contents --}}
                @for ($i = 0; $i < count($table->columns); $i++)
                    @if ($table->columns[$i]->hasActions === true)
                        {{-- If the current column contains action buttons, print a different class --}}
                        <td class="col-button">
                    @else
                        <td>
                    @endif
                            {{-- The content of the cell --}}
                            {{ $item[$i] }}
                        </td>
                @endfor
            </tr>
        @endforeach

    </table>
</div>
