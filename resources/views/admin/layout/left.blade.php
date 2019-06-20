<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            @foreach($actions as $action)
                <li>
                    <a href="javascript:;">
                        <i class="iconfont left-nav-li" lay-tips="{{$action->name}}">&#xe726;</i>
                        <cite>{{$action->name}}</cite>
                        <i class="iconfont nav_right">&#xe697;</i>
                    </a>
                    <ul class="sub-menu">
                        @foreach($action->children as $children)
                            <li>
                                <a onclick="xadmin.add_tab('{{$children->name}}','{{$children->route ? route($children->route) : ''}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{{$children->name}}</cite>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->