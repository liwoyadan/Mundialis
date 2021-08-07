@extends('admin.layout')

@section('admin-title') Invitation Keys @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Invitation Keys' => 'admin/invitations']) !!}

<h1>Invitation Keys</h1>

<p>Invitation keys can be used to register an account. Users will be able to register by entering the code that is generated with the key. Generated invitations can be deleted only if they have not been used.</p>

{!! Form::open(['url' => 'admin/invitations/create', 'class' => 'text-right mb-3']) !!}
    {!! Form::submit('Generate New Invitation', ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
@if(!count($invitations))
    <p>No invitations found.</p>
@else
    {!! $invitations->render() !!}
      <div class="row ml-md-2">
        <div class="d-flex row flex-wrap col-12 pb-1 px-0 ubt-bottom">
          <div class="col-6 col-md-2 font-weight-bold">Code</div>
          <div class="col-6 col-md-2 font-weight-bold">Generated by</div>
          <div class="col-6 col-md-2 font-weight-bold">Used by</div>
          <div class="col-6 col-md-2 font-weight-bold">Used</div>
          <div class="col-6 col-md-3 font-weight-bold">Created</div>
        </div>
        @foreach($invitations as $invitation)
        <div class="d-flex row flex-wrap col-12 mt-1 pt-1 px-0 ubt-top">
          <div class="col-6 col-md-2">{{ $invitation->code }}</div>
          <div class="col-6 col-md-2">{!! $invitation->user->displayName !!}</div>
          <div class="col-6 col-md-2">@if($invitation->recipient_id) {!! $invitation->recipient->displayName !!} @else --- @endif</div>
          <div class="col-6 col-md-2">@if($invitation->created_at != $invitation->updated_at) {!! pretty_date($invitation->updated_at) !!} @else --- @endif</div>
          <div class="col-6 col-md-3">{!! pretty_date($invitation->created_at, false) !!}</div>
          <div class="col-6 col-md-1">
            @if(!$invitation->recipient_id)
              {!! Form::open(['url' => 'admin/invitations/delete/'.$invitation->id]) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger  py-0 px-1']) !!}
              {!! Form::close() !!}
            @endif
          </div>
        </div>
        @endforeach
      </div>

    {!! $invitations->render() !!}
    <div class="text-center mt-4 small text-muted">{{ $invitations->total() }} result{{ $invitations->total() == 1 ? '' : 's' }} found.</div>
@endif

@endsection
