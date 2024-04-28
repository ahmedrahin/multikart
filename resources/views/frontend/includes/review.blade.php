
<div id="top-review">
    @if( Auth::check() )
        @php
            $product_review = App\Models\Review::where('product_id', $product_detail->id)->where('user_id', Auth::user()->id)->first();
        @endphp
        @if( !(isset($product_review)) )
            <form action="{{ route('review-store') }}" method="post" class="theme-form" name="reviewForm">
                @csrf
                <h3>Leave a review</h3>
                <div class="form-row row">
                    <div class="col-md-12">
                        <div class="media mb-1">
                            <label>Rating:</label>
                            <div class="media-body ms-3">
                                <fieldset class="rating">
                                    <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="5 stars"></label>
                                    <input type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="4.5 stars"></label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="4 stars"></label>
                                    <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="3.5 stars"></label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="3 stars"></label>
                                    <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="2.5 stars"></label>
                                    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="2 stars"></label>
                                    <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="1.5 stars"></label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="1 star"></label>
                                    <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="0.5 stars"></label>
                                    <input type="radio" class="reset-option" name="rating" value="reset" />
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="review">Write Review:</label>
                        <textarea class="form-control" placeholder="Wrire Your Testimonial Here.."
                            id="review" name="review" rows="6"></textarea>
                            @error('review')
                                <div class="text-danger">{{$message}}</div>
                            @enderror
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="productId" value="{{ $product_detail->id }}">
                        <button class="btn btn-solid" name="submit" type="submit" id="submitReview">
                            Submit YOur Review
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="user-review">
                <h4>You already submited your review for this product</h4>
                <p>Your Rating: 
                    @if( $product_review->rating == 5 )
                        <div class="rating fiveStar">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    @elseif( $product_review->rating == 4.5 )
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                        </div>
                    @elseif( $product_review->rating == 4 )
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star norating"></i>
                        </div>
                    @elseif( $product_review->rating == 3.5 )
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                            <i class="fa fa-star norating"></i>
                        </div>
                    @elseif( $product_review->rating == 3 )
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                        </div>
                    @elseif( $product_review->rating == 2.5 )
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                        </div>
                    @elseif( $product_review->rating == 2 )
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                        </div>
                    @elseif( $product_review->rating == 1.5 )
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                        </div>
                    @elseif( $product_review->rating == 1 )
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                        </div>
                    @elseif( $product_review->rating == 0.5 )
                        <div class="rating">
                            <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                            <i class="fa fa-star norating"></i>
                        </div>
                    @endif
                    {{ $product_review->rating }} Star
                </p>
                <div></div>
                <p>
                    Your Review:
                </p>
                <span>{{ $product_review->review }}</span>
                <div class="delReview">
                    <form action="{{route('review-delete', $product_review->id)}}" method="POST" id="delReviewForm">
                        @csrf
                        @method('DELETE')
                        <button id="deleteReview">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endif
    @else
        <div class="alert alert-warning">
            You must be login before review! <a href="{{ route('login') }}">Please Login.</a>
        </div>
    @endif
</div>
{{-- previous review --}}
@if( $reviews->count() != 0 )
    <div class="customer-review">
        <h3>Customer's Reviews</h3>
        @foreach( $reviews as $review )
            <div class="allReview">
                <ul>
                    <li>
                        @if( !is_null($review->user->image) )
                            <img src="{{ asset('uploads/user/' . $review->user->image) }}" alt="">
                        @else
                            <img src="{{ asset('backend/images/user.jpg') }}" alt="">
                        @endif
                    </li>
                    <li class="messageItem">
                        <span>{{ $review->user->name }}</span>
                        <p>{{ $review->review }}</p>
                        @if( $review->rating == 5 )
                            <div class="rating fiveStar">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        @elseif( $review->rating == 4.5 )
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                            </div>
                        @elseif( $review->rating == 4 )
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star norating"></i>
                            </div>
                        @elseif( $review->rating == 3.5 )
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                <i class="fa fa-star norating"></i>
                            </div>
                        @elseif( $review->rating == 3 )
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                            </div>
                        @elseif( $review->rating == 2.5 )
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                            </div>
                        @elseif( $review->rating == 2 )
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                            </div>
                        @elseif( $review->rating == 1.5 )
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                            </div>
                        @elseif( $review->rating == 1 )
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                            </div>
                        @elseif( $review->rating == 0.5 )
                            <div class="rating">
                                <i class="fa fa-star-half-o noteqaul" aria-hidden="true"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                                <i class="fa fa-star norating"></i>
                            </div>
                        @endif
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
@endif
