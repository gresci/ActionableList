<div class="responsive-table-container">
    <table class="table responsive-table">
        <thead>
            <tr>
                @foreach($table->columns as $column)
                    <th class="col-testo">
                        {{ $column->name }}

                        @if (! empty($column->sortableName))
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
                @endforeach

                @if (! empty($table->actions))
                    <th class="col-button">
                        &nbsp;
                    </th>
                @endif
            </tr>
        </thead>

        @foreach ($table->items as $item)
            <tr>
                @for ($i = 0; $i < count($table->columns); $i++)
                    <td>
                        {{ $item[$i] }}
                    </td>
                @endfor

                @if (! empty($table->actions))
                    <td class="col-button">
                        @foreach ($table->actions as $action)
                            {{ $action }}
                        @endforeach
                    </td>
                @endif
            </tr>
        @endforeach

    </table>
</div>
