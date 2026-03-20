<tr>
<td class="header">
@php
	$logoPath = public_path('images/logo/inovcorp.png');
	$logoSrc = file_exists($logoPath)
		? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
		: asset('images/logo/inovcorp.png');
@endphp
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ $logoSrc }}" class="logo" alt="{{ config('app.name') }}" style="height: 64px; width: auto;">
</a>
</td>
</tr>



