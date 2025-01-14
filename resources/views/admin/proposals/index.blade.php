@extends('layouts.admin')
@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.proposal.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('global.proposal.fields.job') }}
                                    </th>
                                    <th>
                                        {{ trans('global.proposal.fields.proposal_text') }}
                                    </th>
                                    <th>
                                        {{ trans('global.proposal.fields.budget') }}
                                    </th>
                                    <th>
                                        {{ trans('global.proposal.fields.delivery_time') }}
                                    </th>
                                    <th>
                                        {{ trans('global.proposal.fields.attachments') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proposals as $key => $proposal)
                                    <tr data-entry-id="{{ $proposal->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $proposal->job->title ?? '' }}
                                        </td>
                                        <td>
                                            {{ $proposal->proposal_text ?? '' }}
                                        </td>
                                        <td>
                                            {{ $proposal->budget ?? '' }}
                                        </td>
                                        <td>
                                            {{ $proposal->delivery_time ?? '' }}
                                        </td>
                                        <td>
                                            @if($proposal->attachments)
                                                @foreach($proposal->attachments as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @can('proposal_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.proposals.show', $proposal->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan
                                            @can('proposal_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.proposals.edit', $proposal->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan
                                            @can('proposal_delete')
                                                <form action="{{ route('admin.proposals.destroy', $proposal->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection