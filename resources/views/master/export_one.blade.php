<table class="table">
    <thead>
    </thead>
    <tr class="text-center">
        <th class="align-middle" rowspan="2">日付</th>
        <th class="align-middle" rowspan="2">曜日</th>
        <th colspan="5">サービス提供実績</th>
        <th class="align-middle" rowspan="2">備考</th>
    </tr>
    <tr class="text-center">
        <th>開始時間</th>
        <th>終了時間</th>
        <th>食事提供加算</th>
        <th>施設外支援</th>
        <th>医療連携体制加算</th>
    </tr>
    <tbody>
        @foreach (array_map(null, $days, $records) as [$day, $record])
        <tr align="center">
            @if ($day == $record)
            <td>{{$day->isoformat('D')}}</td>
            <td>{{$day->isoformat('ddd')}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @else
            <td>{{$day->isoformat('D')}}</td>
            <td>{{$day->isoformat('ddd')}}</td>
            <td>{{substr($record->start_time,0, 5)}}</td>
            <td>{{substr($record->end_time,0, 5)}}</td>
            @if ($record->food == 0)
            <td>無</td>
            @elseif ($record->food == 1)
            <td>
                <font color="red">有</font>
            </td>
            @endif

            @if ($record->outside_support == 0)
            <td>無</td>
            @elseif ($record->outside_support == 2)
            <td>
                <font color="red">有</font>
            </td>
            @endif

            @if ($record->medical__support == 0)
            <td>無</td>
            @elseif ($record->medical__support == 2)
            <td>
                <font color="red">有</font>
            </td>
            @endif

            @if ($record->note)
            <td>{{$record->note}}</td>
            @else
            <td></td>
            @endif

            @endif
        </tr>
        @endforeach
    </tbody>
</table>