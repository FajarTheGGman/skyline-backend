<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Address</th>
            <th>Longitude</th>
            <th>Latitude</th>
            <th>Type</th>
            <th>Rating</th>
            <th>Vicinity</th>
            <th>Photo</th>
            <th>ID Places</th>
        </tr>
    </thead>

    <tbody>
        @foreach( $data as $dt )
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dt->name }}</td>
                <td>{{ $dt->address }}</td>
                <td>{{ $dt->long }}</td>
                <td>{{ $dt->lat }}</td>
                <td>{{ $dt->type }}</td>
                <td>{{ $dt->rating }}</td>
                <td>{{ $dt->vicinity }}</td>
                <td>{{ $dt->photo }}</td>
                <td>{{ $dt->id_places }}</td>
            </tr>
        @endforeach
    </tbody>
</table>