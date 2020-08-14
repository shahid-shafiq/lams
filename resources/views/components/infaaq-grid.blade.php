<div>
    <h4>{{ $title }}</h4>
    <h3>{{count($myinf['infaaq'])}}</h3>
    <div class="-col -mt-5">
<?php
if (count($myinf['infaaq'])) {
    $ms = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    foreach ($myinf['infaaq'] as $item) {
?>
        <div style="font-size:9px; height:17px;">
            <div>
                {{ $item['year'] }}
                <?php
                $mi = 0;
                foreach ($item['month'] as $m) {
                    
                ?>
                <div class="-month" style="
                border:1px solid;
                --border-color: {{ $m === 0 ? 'red' : 'green' }};
                margin:0; padding:0;
                width:15px;height:15px;
                display:inline-block;
                border-color: {{ $m === 0 ? 'red' : 'green' }};
                background-color: {{ $m === 0 ? 'red' : 'green' }};
                "
                tooltop="{{ $m }}" data-toggle="tooltip" title="{{ $ms[$mi] }}">&nbsp;</div>
                <?php
                    $mi += 1;
                }
                ?>
            </div>
        </div>
<?php
    }
}
?>
    </div>
</div>

