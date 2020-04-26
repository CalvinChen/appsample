@extends('yys.layouts.app')


@section('title')
账号详情
@endsection


@section('mainContent')
<h1 class="h3 mb-4 text-gray-800">账号详情</h1>

<div class="row mb-3">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-danger shadow py-2" style="background-color: #FFFCFC">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">御魂总分</div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($account['yuhunScore']) }}
                            <span class="text-secondary">分</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-medal fa-3x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-left-primary shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">御魂数量(+15)</div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($account['lv15']?:sizeof($account['yuhun'])) }}
                            <span class="text-secondary">个</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-coins fa-3x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12 mb-3">
        <div class="card border-left-primary shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">玩家昵称</div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800">
                            {{ $account['nickname'] }}
                            @ {{ $account['serverName'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-circle fa-3x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">御魂跑分 - 按种类划分</h6>
            </div>
            <div class="card-body" style="height:300px">
                <canvas id="score-chart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="mb-4">
    <h1 class="h4 text-gray-800 border-left-secondary pl-2">御魂数量(+15)</h1>
</div>

<div class="row">
    @foreach ($groupByName as $yhName=>$yuhunState)
    <div class="col-lg-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ $yhName }}
                    <span class="text-secondary">{{ array_sum(array_column($yuhunState,'count')) }} 个</span>
                </h6>
            </div>
            <div class="card-body" style="height:240px">
                <canvas id="yuhun-count-{{ $loop->index }}"></canvas>
            </div>
            <script>
                new Chart(document.getElementById('yuhun-count-{{ $loop->index }}'), {
                    type: 'radar',
                    data: {
                        labels: ['6号位','5号位','4号位','3号位','2号位','1号位'],
                        datasets: [{
                            label: '数量',
                            data: @json(array_column($yuhunState,'count'))
                        }]
                    },
                    options: helper.chartRadarOption
                });
            </script>
        </div>
    </div>
    @endforeach
</div>
<script>
    var chart_data = [{
        label: '一号位',
        backgroundColor: window.chartColors.red,
        data: @json(array_values(array_map(function($i) {
            return round($i[5]['score']);
        },
        $groupByName))),
        stack: 'master',
    },
    {
        label: '二号位',
        backgroundColor: window.chartColors.orange,
        data: @json(array_values(array_map(function($i) {
            return round($i[4]['score']);
        },
        $groupByName))),
        stack: 'master',
    },
    {
        label: '三号位',
        backgroundColor: window.chartColors.yellow,
        data: @json(array_values(array_map(function($i) {
            return round($i[3]['score']);
        },
        $groupByName))),
        stack: 'master',
    },
    {
        label: '四号位',
        backgroundColor: window.chartColors.green,
        data: @json(array_values(array_map(function($i) {
            return round($i[2]['score']);
        },
        $groupByName))),
        stack: 'master',
    },
    {
        label: '五号位',
        backgroundColor: window.chartColors.blue,
        data: @json(array_values(array_map(function($i) {
            return round($i[1]['score']);
        },
        $groupByName))),
        stack: 'master',
    },
    {
        label: '六号位',
        backgroundColor: window.chartColors.purple,
        data: @json(array_values(array_map(function($i) {
            return round($i[0]['score']);
        },
        $groupByName))),
        stack: 'master',
    },
    ];
    var config = {
        type: 'bar',
        data: {
            labels: @json(array_keys($groupByName)),
            datasets: chart_data
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    display: true,
                    stacked: true
                }],
                yAxes: [{
                    display: true,
                    stacked: true
                }]
            },
            legend: {
                display: false
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
        }
    };

    var ctx = document.getElementById('score-chart').getContext('2d');
    window.myLine = new Chart(ctx, config);
</script>
@endsection