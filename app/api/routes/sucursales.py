from fastapi import APIRouter, Depends
from sqlalchemy.ext.asyncio import AsyncSession
from app.db.base import SessionLocal
from app.schemas.sucursal import SucursalCreate, SucursalOut
from app.services.sucursal import get_sucursales, create_sucursal
from app.api.routes.auth import get_current_user

router = APIRouter()

async def get_db():
    async with SessionLocal() as session:
        yield session

@router.get("/", response_model=list[SucursalOut])
async def listar_sucursales(db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    return await get_sucursales(db)

@router.post("/", response_model=SucursalOut)
async def crear_sucursal(data: SucursalCreate, db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    return await create_sucursal(db, data)