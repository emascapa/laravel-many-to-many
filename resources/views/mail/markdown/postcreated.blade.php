@component('mail::message')
# Your Post was created successfully

- Title of your post: {{$title}}
- Body of your post: {{$content}}
- Date: {{$date}}


@component('mail::button', ['url' => $postUrl])
Show
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
