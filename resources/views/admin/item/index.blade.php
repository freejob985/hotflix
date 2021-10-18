@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Title')</th>
                                <th scope="col">@lang('Category')</th>
                                <th scope="col">@lang('Sub Category')</th>
                                <th scope="col">@lang('Item Type')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td data-label="@lang('Title')">{{ $item->title }}</td>
                                    <td data-label="@lang('Category')">{{ $item->category->name }}</td>
                                    <td data-label="@lang('Sub Category')">{{ @$item->sub_category->name }}</td>
                                    <td data-label="@lang('Item Type')">
                                        @if($item->item_type == 1)
                                            <span class="badge badge--success">@lang('Single Item')</span>
                                        @elseif($item->item_type == 2)
                                            <span class="badge badge--primary">@lang('Episode Item')</span>
                                        @else
                                            <span class="badge badge--warning">@lang('Trailer')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('')Status">
                                        @if($item->status == 1)
                                            <span class="badge badge--success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Deactive')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('')Action">
                                        <a href="{{ route('admin.item.edit',$item->id) }}"
                                           class="text-btn btn--primary btn-sm mr-1">
                                            @lang('Edit')
                                        </a>
                                        @if($item->status == 1)
                                            <a href="{{ route('admin.item.status',$item->id) }}"
                                               class="text-btn btn--danger btn-sm mr-1">
                                                @lang('Deactive')
                                            </a>
                                        @else
                                            <a href="{{ route('admin.item.status',$item->id) }}"
                                               class="text-btn btn--success btn-sm mr-1">
                                                @lang('Active')
                                            </a>
                                        @endif
                                        @if($item->item_type == 2)
                                            <a href="{{ route('admin.item.episodes',$item->id) }}"
                                               class="text-btn btn--info btn-sm mr-1">
                                                @lang('Episodes')
                                            </a>
                                        @else
                                            @if($item->video)
                                                <a href="{{ route('admin.item.updateVideo',$item->id) }}"
                                                   class="text-btn btn--info btn-sm mr-1">
                                                    @lang('Update Video')
                                                </a>
                                            @else
                                                <a href="{{ route('admin.item.uploadVideo',$item->id) }}"
                                                   class="text-btn btn--warning btn-sm mr-1">
                                                    @lang('Upload Video')
                                                </a>
                                            @endif
                                        @endif
                                        @if($item->single == 1)
                                            <a href="{{ route('admin.item.single_section',$item->id) }}"
                                               class="text-btn btn--warning btn-sm mr-1" disabled data-toggle="tooltip">
                                                @lang('Selected as Single Section')
                                            </a>
                                        @else
                                            <a href="{{ route('admin.item.single_section',$item->id) }}"
                                               class="text-btn btn--primary btn-sm mr-1" data-toggle="tooltip">
                                                @lang('Set As Single Section')
                                            </a>
                                        @endif
                                        @if($item->featured == 1)
                                            <a href="{{ route('admin.item.featured',$item->id) }}"
                                               class="text-btn btn--warning btn-sm mr-1" data-toggle="tooltip">
                                                @lang('Unfeatured')
                                            </a>
                                        @else
                                            <a href="{{ route('admin.item.featured',$item->id) }}"
                                               class="text-btn btn--info btn-sm mr-1" data-toggle="tooltip">
                                                @lang('Featured')
                                            </a>
                                        @endif
                                        @if($item->trending == 1)
                                            <a href="{{ route('admin.item.trending',$item->id) }}"
                                               class="text-btn btn--warning btn-sm" data-toggle="tooltip">
                                                @lang('Not Trending')
                                            </a>
                                        @else
                                            <a href="{{ route('admin.item.trending',$item->id) }}"
                                               class="text-btn btn--info btn-sm" data-toggle="tooltip">
                                                @lang('Trending')
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">@lang('Item Not Found')</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $items->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <form action="{{ route('admin.item.search') }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Title or Category')"
                   value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
    <a href="{{ route('admin.item.create') }}" class="btn btn--success mr-5"><i
            class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
    </div>
@endpush
