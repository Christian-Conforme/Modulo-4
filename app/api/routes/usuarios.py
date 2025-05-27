from fastapi import APIRouter, Depends
from sqlalchemy.ext.asyncio import AsyncSession
from app.db.base import SessionLocal
from app.schemas.usuario import UsuarioCreate, UsuarioOut
from app.services.usuario import get_usuarios, create_usuario
from app.api.routes.auth import get_current_user

router = APIRouter()

async def get_db():
    async with SessionLocal() as session:
        yield session

@router.get("/", response_model=list[UsuarioOut])
async def listar_usuarios(db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    return await get_usuarios(db)

@router.post("/", response_model=UsuarioOut)
async def crear_usuario(data: UsuarioCreate, db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    return await create_usuario(db, data)