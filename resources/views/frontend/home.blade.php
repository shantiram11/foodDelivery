@extends('layouts.frontend-master')

@section('title', 'Foodymat - Premium Food Delivery')
@section('description', 'Order delicious meals from the comfort of your home. Fresh ingredients, fast delivery, and exceptional taste guaranteed.')
@section('keywords', 'food delivery, restaurant, online ordering, fresh food, fast delivery')

@section('content')

@include('frontend.components.sections.hero')

@include('frontend.components.sections.about')

@include('frontend.components.sections.menu')

@include('frontend.components.sections.order-form')

@include('frontend.components.sections.contact')

@include('frontend.components.sections.testimonials')


@endsection 