<ul>
    @php
        $children = $children->sortBy('order')
    @endphp
    @foreach($children as $child)
        <li>
            {{ $child->name }}
            @if($child->children)
                @include('category.subcategory',['children' => $child->children])
            @endif
        </li>
    @endforeach
</ul>
