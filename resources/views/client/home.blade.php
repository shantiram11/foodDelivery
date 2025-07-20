@extends('layouts.client-master')

@section('title', 'Foodymat - Premium Food Delivery')
@section('description', 'Order delicious meals from the comfort of your home. Fresh ingredients, fast delivery, and exceptional taste guaranteed.')
@section('keywords', 'food delivery, restaurant, online ordering, fresh food, fast delivery')

@section('content')

@include('client.components.sections.hero')

@include('client.components.sections.about')

@include('client.components.sections.why-us')

@include('client.components.sections.menu')

@include('client.components.sections.daily-specials')

@include('client.components.sections.events')

@include('client.components.sections.order-form')

@include('client.components.sections.testimonials')

@include('client.components.sections.gallery')

@include('client.components.sections.team')

@include('client.components.sections.contact')

@endsection 