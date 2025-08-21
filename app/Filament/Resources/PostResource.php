<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'WEBSITE POSTS MANAGEMENT';
    protected static ?string $navigationLabel = 'Posts';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Create a Post')->collapsible()->description('Create Post over here.')->schema([
                    TextInput::make('title')->rules('min:3|max:50')->required(),
                    Select::make('category_id')->label('Category Name')->relationship('category', 'name')->required(),
                    TextInput::make('price')->required()->numeric(),
                    TextInput::make('quantity')->required()->numeric(),
                    MarkdownEditor::make('description')->required()->columnSpanFull(),
                ]),

                Section::make('Photo Upload')->collapsible()->schema([
                    // FileUpload::make('thumbnail')->disk('public')->directory('thumbnails'),
                    FileUpload::make('thumbnail')
                        ->disk('public')
                        ->directory('thumbnails')
                        ->image()
                        ->required(),
                ]),

            ])->columns([
                'default' => 3,
                'sm' => 3,
                'md' => 3,
                'lg' => 3,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->toggleable(),
                TextColumn::make('category.name')->sortable()->searchable()->toggleable(),
                ImageColumn::make('thumbnail')->sortable()->searchable()->toggleable(),
                TextColumn::make('title')->sortable()->searchable()->toggleable(),
                TextColumn::make('description')->sortable()->searchable()->toggleable(),
                TextColumn::make('price')->sortable()->searchable()->toggleable(),
                TextColumn::make('quantity')->sortable()->searchable()->toggleable(),
                TextColumn::make('created_at')->label('Date')->date()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('category_id')->label('Category Name')->relationship('category', 'name')->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}