    Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('like.destroy');