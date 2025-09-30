@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">E-Commerce Demo</h1>
    <h2>Categories</h2>

    <ul>
        @foreach($categories as $category)
        <li>
            <a href="{{ route('categories.show', $category->slug) }}">
                {{ $category->name }}
            </a>

            @if($category->childrenRecursive->count())
            <ul>
                @foreach($category->childrenRecursive as $child)
                <li>
                    <a href="{{ route('categories.show', $child->slug) }}">
                        {{ $child->name }}
                    </a>
                    @if($child->childrenRecursive->count())
                    <ul>
                        @foreach($child->childrenRecursive as $c)
                        <li>
                            <a href="{{ route('categories.show', $c->slug) }}">
                                {{ $c->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
    </ul>
</div>
@endsection
