@props(['url'])
<tr>
<td class="header">
<table align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="left" style="padding: 0 10px;">
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ config('app.url') }}/images/logo-pasion.png" class="logo-mail" alt="{{ config('app.name') }}">
</a>
</td>
<td align="right" style="padding: 0 10px;">
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ config('app.url') }}/images/logo-toni.png" class="logo-mail" alt="{{ config('app.name') }}">
</a>
</td>
</tr>
</table>
</td>
</tr>
