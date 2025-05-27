from fastapi import APIRouter, Depends
from sqlalchemy.ext.asyncio import AsyncSession
from app.db.base import SessionLocal
from app.schemas.vehiculo_sucursal import VehiculoSucursalCreate, VehiculoSucursalOut
from app.services.vehiculo_sucursal import get_relaciones, create_relacion
from app.api.routes.auth import get_current_user

router = APIRouter()

async def get_db():
    async with SessionLocal() as session:
        yield session

@router.get("/", response_model=list[VehiculoSucursalOut])
async def listar_relaciones(db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    return await get_relaciones(db)

@router.post("/", response_model=VehiculoSucursalOut)
async def crear_relacion(data: VehiculoSucursalCreate, db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    return await create_relacion(db, data)