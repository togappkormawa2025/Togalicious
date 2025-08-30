<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kasir</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Diskon</th>
            <th>Bayar</th>
            <th>Kembalian</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan as $row)
            <tr>
                <td>{{ $row->created_at->format('d M Y H:i') }}</td>
                <td>{{ $row->cashier }}</td>
                <td>{{ $row->customer ?? '-' }}</td>
                <td>{{ $row->total }}</td>
                <td>{{ $row->discount }}</td>
                <td>{{ $row->pay }}</td>
                <td>{{ $row->change }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
