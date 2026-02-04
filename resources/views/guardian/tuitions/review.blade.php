@extends('layouts.app')

@section('title', 'Write Review')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('guardian.tuitions.show', $tuition->id) }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Tuition
        </a>

        <!-- Header -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Write a Review</h1>
            <p class="text-gray-600 mt-2">Share your experience with {{ $tuition->tutor->user->full_name }}</p>
        </div>

        <!-- Tutor Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex items-center gap-4">
                @if($tuition->tutor->photo)
                    <img src="{{ asset('storage/' . $tuition->tutor->photo) }}" 
                        alt="Photo" class="w-16 h-16 rounded-full object-cover">
                @else
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-blue-600 font-semibold text-xl">
                            {{ substr($tuition->tutor->user->first_name, 0, 1) }}
                        </span>
                    </div>
                @endif
                <div>
                    <p class="font-bold text-gray-800 text-lg">{{ $tuition->tutor->user->full_name }}</p>
                    <p class="text-sm text-gray-600">{{ $tuition->post->post_code }} • {{ $tuition->post->classLevel->name }}</p>
                    <p class="text-sm text-gray-600">{{ $tuition->start_date->format('d M Y') }} - {{ $tuition->end_date->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Review Form -->
        <form action="{{ route('guardian.tuitions.review', $tuition->id) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf

            <!-- Rating -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Rating <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2" id="rating-container">
                    @for($i = 1; $i <= 5; $i++)
                        <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" 
                            {{ old('rating') == $i ? 'checked' : '' }} class="hidden rating-input" required>
                        <label for="rating-{{ $i }}" 
                            class="cursor-pointer text-4xl transition-colors rating-star {{ old('rating') >= $i ? 'text-yellow-500' : 'text-gray-300' }} hover:text-yellow-500">
                            ★
                        </label>
                    @endfor
                </div>
                @error('rating')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-2" id="rating-text">Select a rating</p>
            </div>

            <!-- Comment -->
            <div class="mb-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">
                    Review Comment
                </label>
                <textarea name="comment" id="comment" rows="6" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Share your experience with this tutor. What did you like? How did they help your student?">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Optional, but helpful for other guardians</p>
            </div>

            <!-- Review Guidelines -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-800 mb-2">Review Guidelines</h3>
                <ul class="text-sm text-blue-700 space-y-1 list-disc list-inside">
                    <li>Be honest and fair in your assessment</li>
                    <li>Focus on the tutor's teaching abilities and professionalism</li>
                    <li>Mention specific aspects that were good or need improvement</li>
                    <li>Avoid personal attacks or offensive language</li>
                    <li>Your review helps other guardians make informed decisions</li>
                </ul>
            </div>

            <!-- Confirmation -->
            <div class="mb-6">
                <label class="flex items-start">
                    <input type="checkbox" name="confirm_review" value="1" required
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1">
                    <span class="ml-3 text-sm text-gray-700">
                        I confirm that this review is based on my actual experience with this tutor. I understand that false or misleading reviews may be removed.
                    </span>
                </label>
                @error('confirm_review')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                    class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Submit Review
                </button>
                <a href="{{ route('guardian.tuitions.show', $tuition->id) }}" 
                    class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Rating star interaction
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingInputs = document.querySelectorAll('.rating-input');
    const ratingText = document.getElementById('rating-text');
    
    const ratingLabels = {
        1: '1 Star - Poor',
        2: '2 Stars - Fair',
        3: '3 Stars - Good',
        4: '4 Stars - Very Good',
        5: '5 Stars - Excellent'
    };

    ratingStars.forEach((star, index) => {
        star.addEventListener('click', () => {
            updateRating(index + 1);
        });

        star.addEventListener('mouseenter', () => {
            highlightStars(index + 1);
        });
    });

    document.getElementById('rating-container').addEventListener('mouseleave', () => {
        const checkedRating = document.querySelector('.rating-input:checked');
        if (checkedRating) {
            highlightStars(parseInt(checkedRating.value));
        } else {
            highlightStars(0);
        }
    });

    function updateRating(rating) {
        ratingInputs[rating - 1].checked = true;
        highlightStars(rating);
        ratingText.textContent = ratingLabels[rating];
    }

    function highlightStars(rating) {
        ratingStars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-500');
            } else {
                star.classList.remove('text-yellow-500');
                star.classList.add('text-gray-300');
            }
        });
    }

    // Initialize on page load if old value exists
    const checkedRating = document.querySelector('.rating-input:checked');
    if (checkedRating) {
        highlightStars(parseInt(checkedRating.value));
        ratingText.textContent = ratingLabels[checkedRating.value];
    }
</script>
@endsection
