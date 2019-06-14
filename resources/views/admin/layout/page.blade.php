<div class="layui-card-body " >
    <div class="page">
        <div>
            <a class="prev" href="{{$data->previousPageUrl()}}">&lt;&lt;</a>
            @for($i = 1; $i < $data->lastPage() + 1; $i++)
                @if($data->currentPage() == $i)
                    <span class="current">{{$i}}</span>
                @else
                    <a class="num" href="{{$data->url($i)}}">{{$i}}</a>
                @endif
            @endfor
            <a class="next" href="{{$data->nextPageUrl()}}">&gt;&gt;</a>
        </div>
    </div>
</div>