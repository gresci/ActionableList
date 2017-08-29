<div class="responsive-table-container">
    <table class="table responsive-table">
        <thead>
            <tr>
                @foreach($catalog->columns as $column)
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
                
                @if (! empty($catalog->actions))
                    <th class="col-button">
                        &nbsp;
                    </th>
                @endif
            </tr>
        </thead>

        @foreach ($catalog->items as $item)
            <tr>
                @for ($i = 0; $i < count($catalog->columns); $i++)
                    <td>
                        {{ $item[$i] }}
                    </td>
                @endfor
                
                @if (! empty($catalog->actions))
                    <td class="col-button">
                        @foreach ($catalog->actions as $action)
                            <a href="{{-- url($bladeParams['baseUrl'].'/'.$info->id.'/edit') --}}" class="btn btn-main btn-circle m-2" title="Modifica">
                            <span class="icon icon-pencil"></span></a>
                        @endforeach
                    </td>
                @endif
            </tr>
        @endforeach

    </table>
</div>
