<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
    Simple Select Component
    <ul>
    @foreach ($data as $key => $item)
        <li style="color: {{ $key==$type ? 'red' : 'blue' }}">
        {{$key}} => {{$item}}
        </li>
    @endforeach
    </ul>
</div>