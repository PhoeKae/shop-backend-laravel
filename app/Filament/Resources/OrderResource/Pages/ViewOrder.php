<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Customer Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('customer_name')->label('Name'),
                        Infolists\Components\TextEntry::make('customer_phone')->label('Phone'),
                        Infolists\Components\TextEntry::make('customer_address')->label('Address'),
                        Infolists\Components\TextEntry::make('notes')->label('Notes'),
                    ])
                    ->columns(2),
                Infolists\Components\Section::make('Order Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')->label('Status'),
                        Infolists\Components\TextEntry::make('payment_status')->label('Payment Status'),
                        Infolists\Components\TextEntry::make('total_amount')
                            ->label('Total')
                            ->formatStateUsing(fn ($state) => number_format($state, 2) . ' Ks'),
                        Infolists\Components\TextEntry::make('created_at')->label('Created At'),
                    ])
                    ->columns(2),
                Infolists\Components\Section::make('Order Items')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('orderItems')
                            ->schema([
                                Infolists\Components\TextEntry::make('post.title')->label('Product'),
                                Infolists\Components\TextEntry::make('quantity')->label('Qty'),
                                Infolists\Components\TextEntry::make('unit_price')
                                    ->label('Unit Price')
                                    ->formatStateUsing(fn ($state) => number_format($state, 2) . ' Ks'),
                                Infolists\Components\TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->formatStateUsing(fn ($state) => number_format($state, 2) . ' Ks'),
                            ])
                            ->columns(4),
                    ]),
            ]);
    }
}
